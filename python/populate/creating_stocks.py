#!/usr/bin/env python3

import json
import requests
import csv
from models.stock import Stock

CSV_FILE = "stock50.csv"

def get_stocks_csv(csv_name):
    stocks = []
    with open(csv_name, newline='') as fd:
        reader = csv.reader(fd)
        for row in reader:
            stocks.append({'ticker': row[0],
                           'name': row[1],
                           'market_cap': float(row[2]),
                           'sector': row[3]})
    return stocks

def get_stocks_data(chosen_stocks):
    res = requests.get('http://data.okfn.org/data/core/s-and-p-500-companies/r/constituents-financials.json')
    stocks_info = json.loads(res.text)
    stocks_info = list(filter(lambda stock: stock['Symbol'] in chosen_stocks, stocks_info))
    return stocks_info

for stock in get_stocks_csv(CSV_FILE):
    if not Stock(stock).save():
        print("ERROR: not able to save the following stock \n {}".format(stock.serialize()))
