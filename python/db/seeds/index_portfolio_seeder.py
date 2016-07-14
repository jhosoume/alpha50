from orator.seeds import Seeder


class IndexPortfolioSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.db.table('portfolios').insert()

