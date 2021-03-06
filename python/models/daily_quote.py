import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator import Model
from config import db
from orator.orm import belongs_to
import numbers
import arrow

Model.set_connection_resolver(db)

class DailyQuote(Model):

    __fillable__ = ['date', 'close_price']
    __dates__ = ['date']
    __timestamps__ = False

    @belongs_to
    def stock(self):
        import models.stock
        return models.stock.Stock

    @staticmethod
    def is_valid_close_price(close_price):
        valid = isinstance(close_price, numbers.Number)
        return True if valid else False

    @staticmethod
    def is_valid_date(date):
        try:
            valid = date and isinstance(date, arrow.Arrow) and \
                    date > arrow.get('2008-12-31', 'YYYY-MM-DD').to('PST') and \
                    date < arrow.now().replace(minutes = +5)
        except:
            valid = date and isinstance(date, arrow.Arrow) and \
                    date > arrow.get('2008-12-31', 'YYYY-MM-DD').to('US/Pacific') and \
                    date < arrow.now().replace(minutes = +5)

        return True if valid else False

    def is_valid(self):
        return DailyQuote.is_valid_close_price(self.close_price) and \
               DailyQuote.is_valid_date(self.date)

    def is_unique(self):
        count = DailyQuote.where('stock_id', self.stock_id).where('date', self.date.format('YYYY-MM-DDTHH:mm:ss')).count()
        return True if (count == 0) else False

DailyQuote.creating(lambda daily_quote: daily_quote.is_unique())
DailyQuote.saving(lambda daily_quote: daily_quote.is_valid())
