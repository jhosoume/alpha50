from orator.seeds import Seeder


class DatabaseSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.call(IndexPortfolioSeeder)

