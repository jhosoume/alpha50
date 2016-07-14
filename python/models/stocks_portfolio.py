from orator import Model
from config import db
from orator.orm import belongs_to, has_many
import numbers

Model.set_connection_resolver(db)

class StocksPortfolio(Model):

    __fillable__ = ['stock_id', 'portfolio_id', 'quantity_held']
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
        return qty and isinstance(qty, numbers.Number)

    def is_valid(self):
        return StocksPortfolio.is_valid_quantity_held(self.quantity_held)

    def is_unique(self):
        count = StocksPortfolio.where('stock_id', self.stock_id).where('portfolio_id', self.portfolio_id)
        return True if (count <= 0) else False

StocksPortfolio.saving(lambda stocks_portfolio: stocks_portfolio.is_valid() and StocksPortfolio.is_unique())



