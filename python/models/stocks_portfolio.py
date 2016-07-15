import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator import Model
from config import db
from orator.orm import belongs_to, has_many
import numbers

Model.set_connection_resolver(db)

class StocksPortfolio(Model):

    __fillable__ = ['stock_id', 'portfolio_id', 'quantity_held']
    __guarded__ = ['id']
    __timestamps__ = False

    @belongs_to
    def portfolio(self):
        import models.portfolio
        return models.portfolio.Portfolio

    @belongs_to
    def stock(self):
        import models.stock
        return models.stock.Stock

    @has_many
    def trades(self):
        import models.trade
        return models.trade.Trade

    @staticmethod
    def is_valid_quantity_held(qty):
        valid = qty and isinstance(qty, numbers.Number)
        return True if valid else False

    def is_valid(self):
        return StocksPortfolio.is_valid_quantity_held(self.quantity_held)

    def is_unique(self):
        count = StocksPortfolio.where('stock_id', self.stock_id).where('portfolio_id', self.portfolio_id).count()
        return True if not count else False

StocksPortfolio.creaing(lambda stocks_portfolio: stocks_portfolio.is_unique())
StocksPortfolio.saving(lambda stocks_portfolio: stocks_portfolio.is_valid())
