import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator import Model
from config import db
from orator.orm import has_one, belongs_to, has_many_through, has_many
import numbers
import models.stocks_portfolio

Model.set_connection_resolver(db)

class Portfolio(Model):

    __fillable__ = ['user_id', 'parent', 'name', 'total_cash']
    __timestamps__ = True

    @has_one
    def portfolio(self):
        return Portfolio

    @belongs_to
    def user(self):
        import models.user
        return models.user.User

    @has_many
    def stocks_portfolios(self):
        return models.stocks_portfolio.StocksPortfolio

    @has_many_through(models.stocks_portfolio.StocksPortfolio)
    def trade(self):
        import models.trade
        return models.trade.Trade

    @staticmethod
    def is_valid_cash(cash):
        valid = cash and isinstance(cash, numbers.Number)

    @staticmethod
    def is_valid_name(name):
        return True if name else False

    def is_valid(self):
        return Portfolio.is_valid_cash(self.total_cash) and \
               Portfolio.is_valid_name(self.name)

    def is_unique(self):
        count = Portfolio.where('user_id', self.user_id).where('name', self.name).count()
        return True if (count <= 0) else False

Portfolio.creating(lambda portfolio: portfolio.is_unique())
Portfolio.saving(lambda portfolio: portfolio.is_valid())
