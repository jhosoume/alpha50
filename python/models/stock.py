from orator import Model
from config import db
from orator.orm import has_many
import numbers
from models.hourly_quote import HourlyQuote
from models.daily_quote import DailyQuote

Model.set_connection_resolver(db)

class Stock(Model):

    __fillable__ = ['name', 'sector', 'ticker', 'market_cap']
    __guarded__ = ['id']
    __timestamps__ = False

    @has_many
    def hourly_quotes(self):
        return HourlyQuote

    @has_many
    def daily_quotes(self):
        return DailyQuote

    #@has_many
    #def stocks_portfolios(self):
        #return 
    
    @staticmethod
    def is_valid_ticker(ticker):
        valid = ticker and ticker.isupper() and len(ticker) < 6
        return True if valid else False
    
    @staticmethod
    def is_valid_sector(sector):
        valid = sector and (sector in ['Consumer Discretionary', 
                                      'Consumer Staples', 
                                      'Energy',
                                      'Financials',
                                      'Health Care',
                                      'Industrials',
                                      'Information Technology',
                                      'Telecommunications Services'])
        return True if valid else False

    @staticmethod
    def is_valid_market_cap(market_cap):
        valid =  market_cap and isinstance(market_cap, numbers.Number) and market_cap > 1
        return True if valid else False

    def is_valid(self):
        return Stock.is_valid_ticker(self.ticker) and \
               Stock.is_valid_sector(self.sector) and \
               Stock.is_valid_market_cap(self.market_cap)

    def is_unique(self):
        return True if not Stock.where('ticker', self.ticker).count() else False

Stock.creating(lambda stock: stock.is_valid() and stock.is_unique())
