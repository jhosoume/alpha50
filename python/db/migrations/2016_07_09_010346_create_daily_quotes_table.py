from orator.migrations import Migration


class CreateDailyQuotesTable(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.create('daily_quotes') as table:
            table.increments('id')
            table.integer('stock_id').unsigned()
            table.foreign('stock_id').references('id').on('stocks')
            table.date('date')
            table.float('close_price')

    def down(self):
        """
        Revert the migrations.
        """
        self.schema.drop('daily_quotes')
