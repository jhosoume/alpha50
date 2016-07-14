from orator import Model
from config import db
from orator.orm import belongs_to
import numbers

Model.set_connection_resolver(db)


class Trade(Model):

    __fillable__ = ['stocks_portfolio_id', 'quantity',' price']
    __timestamps__ = ['created_at']

    @belongs_to
    def stocks_portfolio(self):
        return StocksPortfolio

    @staticmethod
    def is_valid_quantity(qty):
        valid = qty and isinstance(qty, numbers.Number) and qty >= 0
        return True if valid else False

    def is_valid(self):
        return Trade.is_valid_quantity(self.quantity)

    def is_unique(self):
        count = Trade.where('stocks_portfolio_id', self.stocks_portfolio_id).where('created_at', self.created_at.format('YYYY-MM-DDTHH:mm:ss'))
        return True if (count <= 0) else False

Trade.saving(lambda trade: trade.is_valid() and trade.is_unique())



