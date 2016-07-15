from orator.migrations import Migration


class CreatePortfolioValuationsTable(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.create('portfolio_valuations') as table:
            table.increments('id')
            table.timestamp('created_at').use_current()
            table.float('value')
            table.integer('portfolio_id').unsigned()
            table.foreign('portfolio_id').references('id').on('portfolios')

    def down(self):
        """
        Revert the migrations.
        """
        self.schema.drop('portfolio_valuations')
