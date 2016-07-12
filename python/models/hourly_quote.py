from orator import Model
from config import db
from orator.orm import belongs_to
import numbers
import arrow

Model.set_connection_resolver(db)

class HourlyQuote(Model):

    __fillable__ = ['datetime', 'price']
    __dates__ = ['datetime']
    __timestamps__ = False

    @belongs_to
    def stock(self):
        return Stock

    @staticmethod
    def is_valid_datetime(datetime):
        valid = datetime and isinstance(datetime, arrow.Arrow) and \
            datetime > arrow.get('2008-12-31', 'YYYY-MM-DD').to('PST') and \
            datetime < arrow.now().replace(minutes = +5)
        return True if valid else False

    @staticmethod
    def is_valid_price(price):
        valid = price and isinstance(price, numbers.Number)
        return True if valid else False

    def is_valid(self):
        return HourlyQuote.is_valid_price(self.price) and \
               HourlyQuote.is_valid_datetime(self.datetime)

    def is_new_range(self):
        count = HourlyQuote.where_between('datetime', [arrow.now().to('PST').replace(minutes = -30), arrow.now().to('PST').replace(minutes = +30)]).count() 
        return True if (count > 0) else False

    def is_new(self):
        count = HourlyQuote.where('datetime', arrow.now().to('PST').floor('hour')).count()
        return True if (count > 0) else False

HourlyQuote.saving(lambda hourly_quote: hourly_quote.is_valid() and hourly_quote.is_new())
