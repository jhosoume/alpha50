from orator.migrations import Migration


class CreateHourlyQuotesTable(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.create('hourly_quotes') as table:
            table.increments('id')
            table.float('price')
            table.date('date')
            table.integer('stock_id').unsigned()
            table.foreign('stock_id').references('id').on('stocks')

    def down(self):
        """
        Revert the migrations.
        """
        self.schema.drop('hourly_quotes')
