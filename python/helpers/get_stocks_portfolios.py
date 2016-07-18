import csv

def get_stocks_portfolios(csv_name):
    tickers_qty = []
    with open(csv_name, newline='') as fd:
        reader = csv.reader(fd)
        for row in reader:
            tickers_qty.append({'ticker': row[0],
                                'quantity': int(row[1])})
    return tickers_qty
