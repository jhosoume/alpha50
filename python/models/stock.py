import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0, parentdir)

from orator import Model
from config import db
from orator.orm import has_many
import numbers

Model.set_connection_resolver(db)

class Stock(Model):

    __fillable__ = ['name', 'sector', 'ticker', 'market_cap', 'latest_price']
    __guarded__ = ['id']
    __timestamps__ = False

    @has_many
    def half_hourly_quotes(self):
        import models.half_hourly_quote
        return models.half_hourly_quote.HalfHourlyQuote

    @has_many
    def daily_quotes(self):
        import models.daily_quote
        return models.daily_quote.DailyQuote

    @has_many
    def stocks_portfolios(self):
        import models.stocks_portfolio
        return models.stocks_portfolio.StocksPortfolio
    
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

Stock.creating(lambda stock: stock.is_unique())
Stock.saving(lambda stock: stock.is_valid())
