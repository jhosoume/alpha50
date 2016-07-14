from orator.seeds import Seeder


class IndexPortfolioSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.db.table('portfolios').insert({
            'name': 'Alpha50',
            'cash': 0.0})
        


