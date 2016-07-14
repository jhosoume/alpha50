from orator import Model
from config import db
from orator.orm import has_one, belongs_to, has_many_through, has_many
import numbers

Model.set_connection_resolver(db)

class Portfolio(Model):

    __fillable__ = ['user_id', 'parent', 'name', 'cash']
    __timestamps__ = True

    @has_one
    def portfolio(self):
        return Portfolio

    @belongs_to
    def user(self):
        return User

    @has_many
    def stocks_portfolios(self):
        return StocksPortfolio

    @has_many_through(StocksPortfolio)
    def trade(self):
        return Trade

    @staticmethod
    def is_valid_cash(cash):
        valid = cash and isinstance(cash, numbers.Number)

    @staticmethod
    def is_valid_name(name):
        return True if name else False

    def is_valid(self):
        return Portfolio.is_valid_cash(self.cash) and \
               Portfolio.is_valid_name(self.name)

    def is_unique(self):
        count = Portfolio.where('user_id', self.user_id).where('name', self.name).count()
        return True if (count <= 0) else False

Portfolio.saving(lambda portfolio: portfolio.is_valid() and portfolio.is_unique())
