import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator import Model
from config import db
from orator.orm import belongs_to
import numbers
import models.stocks_portfolio

Model.set_connection_resolver(db)


class Trade(Model):

    __fillable__ = ['stocks_portfolio_id', 'quantity', 'price']
    __timestamps__ = False
    __timestamps__ = ['created_at']

    @belongs_to
    def stocks_portfolio(self):
        return models.stocks_portfolio.StocksPortfolio

    @staticmethod
    def is_valid_quantity(qty):
        valid = qty and isinstance(qty, numbers.Number) and qty >= 0
        return True if valid else False

    def is_valid(self):
        return Trade.is_valid_quantity(self.quantity)

    def is_unique(self):
        count = Trade.where('stocks_portfolio_id', self.stocks_portfolio_id).where('created_at', self.created_at.format('YYYY-MM-DDTHH:mm:ss')).count()
        return True if (count <= 1) else False
    
    @staticmethod
    def delete_repeated(trade):
        if not trade.is_unique():
            trade.delete()
            return False
        return True

Trade.created(lambda trade: Trade.delete_repeated(trade)) 
Trade.saving(lambda trade: trade.is_valid()) 



