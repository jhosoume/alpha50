from orator.migrations import Migration


class CreateStocksPortifoliosTable(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.create('stocks_portfolios') as table:
            table.increments('id')
            table.integer('stock_id').unsigned()
            table.foreign('stock_id').references('id').on('stocks')
            table.integer('portfolio_id').unsigned()
            table.foreign('portfolio_id').references('id').on('portfolios')

    def down(self):
        """
        Revert the migrations.
        """
        self.schema.drop('stocks_portfolios')
