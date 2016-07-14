import csv

def get_portfolio_csv(csv_name):
    tickers_qty = []
    with open(csv_name, newline='') as fd:
        reader = csv.reader(fd)
        for row in reader:
            tickers_qty.append({'ticker': row[0],
                                'quantity': row[1],
                                'price': row[2]})
    return tickers_qty
