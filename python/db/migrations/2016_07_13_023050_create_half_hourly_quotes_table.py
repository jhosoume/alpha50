from orator.migrations import Migration


class CreateHalfHourlyQuotes(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.create('half_hourly_quotes') as table:
            table.increments('id')
            table.float('price')
            table.datetime('datetime')
            table.integer('stock_id').unsigned()
            table.foreign('stock_id').references('id').on('stocks')

    def down(self):
        """
        Revert the migrations.
        """
        self.schema.drop('half_hourly_quotes')
