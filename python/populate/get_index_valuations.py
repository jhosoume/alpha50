#!/usr/bin/env python3

import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

import arrow
from decimal import Decimal
from models.stock import Stock
from models.daily_quote import DailyQuote

CSV_FILE = '../csvs/index_valuations.csv'
SECTORS = ['information_technology', 'energy', 'consumer_discretionary', 'health_care', 'industrials', 'telecommunications_services', 'financials', 'consumer_staples'] 


def get_index_value_history(csv_name):
    date_prices = []
    with open(csv_name, newline='') as fd:
        reader = csv.reader(fd)
        for row in reader:
            date_prices.append({'date': row[0],
                           'portfolio_value': row[1]})
            for indx, sector in enumerate(SECTORS):
                date_prices[sector] = row[2 + indx]
    return date_prices

if __name__ == '__main__': 
    for date_price in get_index_value_history():
        pass


