import csv
import arrow
#from helpers.get_valuations import datetime_from_string => see get_valuations.py,
# Have to redefine the function to get dates, because csvs don't have a pattern for date definition

def datetime_from_string(date):
    datetime = arrow.now('US/Pacific')
    datetime = datetime.replace(hour = 13, minute = 0, second = 0)
    year = int('20' + date[:2])
    month = int(date[3:-3])
    day = int(date[-2:])
    return datetime.replace(year = year, month = month, day = day).format('YYYY-MM-DDTHH:mm:ss')

def get_trades(csv_name):
    tickers_qty_value = []
    with open(csv_name, newline='') as fd:
        reader = csv.reader(fd)
        for row in reader:
            tickers_qty_value.append({'created_at': datetime_from_string(row[0]),
                                'ticker': row[2],
                                'quantity': int(row[1]),
                                'price': float(row[3])})
    return tickers_qty_value
