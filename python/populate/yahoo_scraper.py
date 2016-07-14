#!/usr/bin/env python3

import requests
import arrow
from pyquery import PyQuery as pq
from retrying import retry
from models.stock import Stock

YAHOO_URL = 'https://ca.finance.yahoo.com/quotes/{}'
MAX_ATTEMPS = 25
INTERVAL = 60000 # in ms

def parse_datetime(time):
    hour = int(time[:2])
    minute = int(time[3:5])
    zone = time[-3:] 
    am_pm = time[5:7]
    if (am_pm.lower() == 'pm' and hour + 12 in (range(24))):
        hour += 12
    if (zone != 'EDT'): 
        print('ERROR: problem with timezone')
    return arrow.now('US/Eastern').replace(hour = hour, minute = minute, second = 0)

@retry(stop_max_attempt_number = MAX_ATTEMPS,
       wait_random_min = INTERVAL - 10000,
       wait_random_max = INTERVAL)
def get_yahoo_page(url):
    return requests.get(url)

def get_info_from_row(row):
    ticker = row.children('.col-symbol').text()
    time = parse_datetime(row.children('.col-time').text())
    price = float(row.children('.col-price').text())
    return {'ticker': ticker,
            'info': {'datetime': time.to('US/Pacific'),
                     'price': price
                     }}

def scrape_yahoo_site(tickers_list):
    page = get_yahoo_page(YAHOO_URL.format(','.join([ str(ticker) for ticker in tickers_list ])))
    page = pq(page.text) 
    table = page('table.yfi_portfolios_multiquote')
    rows = table.children('tbody').children('tr')
    stocks_prices = []
    for row in rows.items():
        stocks_prices.append(get_info_from_row(row))
    return stocks_prices

