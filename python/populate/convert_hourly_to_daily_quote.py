#!/usr/bin/env python3

import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from models.stock import Stock
from models.half_hourly_quote import HalfHourlyQuote
from models.daily_quote import DailyQuote

def convert_hourly_to_daily():
    for stock in Stock.all():
        older_quotes = HalfHourlyQuote.where('stock_id', stock.id).older().get_models()
        try:
            close_quote = older_quotes[0]
        except:
            return
        info = {'date': close_quote.datetime.format('YYYY-MM-DD'), 
                'close_price': close_quote.price}
        stock.daily_quotes().save(DailyQuote(info))
        for old_quote in older_quotes:
            old_quote.delete()


if __name__ == '__main__':
    convert_hourly_to_daily()
    
    

