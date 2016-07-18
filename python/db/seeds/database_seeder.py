from orator.seeds import Seeder
from seeds.index_portfolio_seeder import IndexPortfolioSeeder
from seeds.index_valuations_seeder import IndexValuationsSeeder
from seeds.scrooge_mcduck_seeder import ScroogeMcDuckSeeder

class DatabaseSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.call(IndexPortfolioSeeder)
        self.call(IndexValuationsSeeder)
        self.call(ScroogeMcDuckSeeder)

