import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator.seeds import Seeder
from helpers.get_portfolio_from_csv import get_portfolio_csv


INDEX_DEFINITION = '../../csvs/alpha_50.csv'

class IndexPortfolioSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.db.table('portfolios').insert({
            'name': 'Alpha50',
            'cash': 0.0})


        stocks = get_portfolio_csv()


        
        


