import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator.seeds import Seeder
import arrow
from helpers.get_index_valuations import get_index_value_history 
import models.user 
import models.portfolio 
import models.portfolio_valuation


INDEX_VALUATIONS = '../csvs/index_valuations.csv'

class IndexValuationsSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        user = models.user.User.where('email', 'admin@alpha50').first()
        portfolio = models.portfolio.Portfolio.where('name', 'Alpha50').where('user_id', user.id).first()
        valuations = get_index_value_history(INDEX_VALUATIONS)
        
        for valuation in valuations:
            valuation['portfolio_id'] = portfolio.id
            models.portfolio_valuation.PortfolioValuation.create(valuation)



