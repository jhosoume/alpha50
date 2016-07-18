import arrow
import csv

SECTORS = ['information_technology', 'energy', 'consumer_discretionary', 'health_care', 'industrials', 'telecommunications_services', 'financials', 'consumer_staples'] 

# TODO Careful with dates! Every csv received has a different date definition! => Ask for a pattern for date definitons
def datetime_from_string(date):
    datetime = arrow.now('US/Pacific')
    datetime = datetime.replace(hour = 13, minute = 0, second = 0)
    year = int(date[:4])
    month = int(date[5:7])
    day = int(date[-2:])
    return datetime.replace(year = year, month = month, day = day).format('YYYY-MM-DDTHH:mm:ss')

def get_portfolio_valuations(csv_name):
    date_prices = []
    with open(csv_name, newline='') as fd:
        reader = csv.reader(fd)
        for nrow, row in enumerate(reader):
            date_prices.append({'created_at': datetime_from_string(row[0]),
                           'portfolio_value': float(row[1])})
            for indx, sector in enumerate(SECTORS):
                date_prices[nrow][sector] = float(row[2 + indx])
    return date_prices

