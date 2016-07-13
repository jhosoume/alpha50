from orator.migrations import Migration


class CreateTradesTable(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.create('trades') as table:
            table.increments('id')
            table.integer('stocks_portfolio_id').unsigned()
            table.foreign('stocks_portfolio_id').references('id').on('stocks_portfolios') 
            table.datetime('datetime')
            table.integer('quantity')
            table.float('price')
            table.timestamp('created_at').use_current()

    def down(self):
        """
        Revert the migrations.
        """
        self.schema.drop('trades')
