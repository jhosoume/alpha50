from orator.seeds import Seeder
from seeds.index_portfolio_seeder import IndexPortfolioSeeder
from seeds.index_valuations_seeder import IndexValuationsSeeder
from seeds.scrooge_mcduck_seeder import ScroogeMcduckSeeder
from seeds.tony_stark_seeder import TonyStarkSeeder
from seeds.jay_gatsby_seeder import JayGatsbySeeder
from seeds.mr_burns_seeder import MrBurnsSeeder
from seeds.gordon_gecko_seeder import GordonGeckoSeeder

class DatabaseSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.call(IndexPortfolioSeeder)
        self.call(IndexValuationsSeeder)
        #self.call(ScroogeMcduckSeeder)
        self.call(TonyStarkSeeder)
        self.call(JayGatsbySeeder)
        self.call(MrBurnsSeeder)
        self.call(GordonGeckoSeeder)

