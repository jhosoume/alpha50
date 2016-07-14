from models.stock import Stock
from models.half_houly_quote import HalfHourlyQuote
from models.daily_quote import DailyQuote

def convert_hourly_to_daily():
    for stock in Stock.all():
        older_quotes = HalfHourlyQuote.where('stock_id', stock.id).older().get_models()
        close_quote = older_quotes[0]
        info = {'date': close_quote.datetime, 
                'close_time': close_quote.price}
        stock.hourly_quotes().save(HourlyQuote(info))
        for old_quote in older_quotes:
            old_quote.delete()

    

