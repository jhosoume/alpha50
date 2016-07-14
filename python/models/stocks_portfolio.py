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
        return Portfolio

    @belongs_to
    def stock(self):
        return Stock

    @has_many
    def trades(self):
        return Trade

    @staticmethod
    def is_valid_quantity_held(qty):
        valid = qty and isinstance(qty, numbers.Number)
        return True if valid else False

    def is_valid(self):
        return StocksPortfolio.is_valid_quantity_held(self.quantity_held)

    def is_unique(self):
        count = StocksPortfolio.where('stock_id', self.stock_id).where('portfolio_id', self.portfolio_id)
        return True if not count else False

StocksPortfolio.saving(lambda stocks_portfolio: stocks_portfolio.is_valid() and stocks_portfolio.is_unique())



