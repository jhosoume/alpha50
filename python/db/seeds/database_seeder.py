from orator.seeds import Seeder
from seeds.index_portfolio_seeder import IndexPortfolioSeeder

class DatabaseSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.call(IndexPortfolioSeeder)

