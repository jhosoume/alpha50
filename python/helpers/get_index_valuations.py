#!/usr/bin/env python3

import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

import arrow
import csv
from decimal import Decimal
from models.stock import Stock
from models.daily_quote import DailyQuote
from models.portfolio import Portfolio

CSV_FILE = '../csvs/index_valuations.csv'
SECTORS = ['information_technology', 'energy', 'consumer_discretionary', 'health_care', 'industrials', 'telecommunications_services', 'financials', 'consumer_staples'] 


def datetime_from_string(date):
    datetime = arrow.now('US/Pacific')
    datetime = datetime.replace(hour = 13, minute = 0, second = 0)
    year = int('20' + date[-2:])
    month = int(date[3:-3])
    day = int(date[0:2])
    return datetime.replace(year = year, month = month, day = day).format('YYYY-MM-DDTHH:mm:ss')


def get_index_value_history(csv_name):
    date_prices = []
    with open(csv_name, newline='') as fd:
        reader = csv.reader(fd)
        for nrow, row in enumerate(reader):
            date_prices.append({'created_at': datetime_from_string(row[0]),
                           'portfolio_value': row[1]})
            for indx, sector in enumerate(SECTORS):
                date_prices[nrow][sector] = row[2 + indx]
    return date_prices



