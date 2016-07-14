from orator import Model
from config import db
from orator.orm import belongs_to, scope
import numbers
import arrow

Model.set_connection_resolver(db)

class HalfHourlyQuote(Model):

    __fillable__ = ['datetime', 'price', 'stock_id']
    __dates__ = ['datetime']
    __timestamps__ = False

    @belongs_to
    def stock(self):
        return Stock

    @staticmethod
    def is_valid_datetime(datetime):
        try:
            valid = datetime and isinstance(datetime, arrow.Arrow) and \
                datetime > arrow.get('2008-12-31', 'YYYY-MM-DD').to('PST') and \
                datetime < arrow.now().replace(minutes = +5)
        except:
            valid = datetime and isinstance(datetime, arrow.Arrow) and \
                datetime > arrow.get('2008-12-31', 'YYYY-MM-DD').to('US/Pacific') and \
                datetime < arrow.now().replace(minutes = +5)
        return True if valid else False

    @staticmethod
    def is_valid_price(price):
        valid = price and isinstance(price, numbers.Number)
        return True if valid else False

    @scope
    def older(self, query):
        def query_older(tz):
            return query.where('datetime', '>', arrow.now().to(tz).replace(days = -5).format('YYYY-MM-DDTHH:mm:ss')).order_by('datetime', 'asc')
        try:
            return query_older('PST')
        except:
            return query_older('US/Pacific')

    def is_valid(self):
        return HalfHourlyQuote.is_valid_price(self.price) and \
               HalfHourlyQuote.is_valid_datetime(self.datetime)

    def is_new_range(self):
        try:
            count = HalfHourlyQuote.where_between('datetime', [arrow.now().to('PST').replace(minutes = -30), arrow.now().to('PST').replace(minutes = +30)]).count() 
        except:
            count = HalfHourlyQuote.where_between('datetime', [arrow.now().to('US/Pacific').replace(minutes = -30), arrow.now().to('US/Pacific').replace(minutes = +30)]).count() 
        return True if (count > 0) else False

    def has_record(self):
        count = HalfHourlyQuote.where('stock_id', self.stock_id).where('datetime', self.datetime.format('YYYY-MM-DDTHH:mm:ss')).count()
        return True if (count > 0) else False

HalfHourlyQuote.saving(lambda half_hourly_quote: half_hourly_quote.is_valid() and not half_hourly_quote.has_record())
