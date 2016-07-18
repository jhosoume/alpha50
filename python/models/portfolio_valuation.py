import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator import Model
from config import db
from orator.orm import belongs_to
import numbers

Model.set_connection_resolver(db)

SECTORS = ['information_technology', 'energy', 'consumer_discretionary', 'health_care', 'industrials', 'telecommunications_services', 'financials', 'consumer_staples']

class PortfolioValuation(Model):

    __fillable__ = ['created_at', 'portfolio_id', 'portfolio_value'] + SECTORS 
    __guarded__ = ['id']
    __timestamps__ = ['created_at'] 

    @belongs_to
    def portfolio(self):
        import models.portfolio
        return models.portfolio.Portfolio

    @staticmethod
    def is_valid_value(value):
        valid = isinstance(value, numbers.Number)
        return True if valid else False

    def is_valid(self):
        valid = [ getattr(self, sector) for sector in SECTORS ]
        valid = map(PortfolioValuation.is_valid_value, valid)
        return all(valid)

    def is_unique(self):
        count = PortfolioValuation.where('portfolio_id', self.portfolio_id).where('created_at', self.created_at.format('YYYY-MM-DDTHH:mm:ss')).count()
        return True if (count <= 1) else False

    @staticmethod
    def delete_repeated(portfolio_valuation):
        if not portfolio_valuation.is_unique():
            portfolio_valuation.delete()
            return False
        return True

PortfolioValuation.created(lambda portfolio_valuation: PortfolioValuation.delete_repeated(portfolio_valuation))
PortfolioValuation.saving(lambda portfolio_valuation: portfolio_valuation.is_valid())
