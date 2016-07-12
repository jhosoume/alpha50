from orator.migrations import Migration


class ChangeColumnDateToDatetimeHourlyQuotes(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.table('hourly_quotes') as table:
            table.datetime('datetime')
            table.drop_column('date')

    def down(self):
        """
        Revert the migrations.
        """
        with self.schema.table('hourly_quotes') as table:
            table.date('date')
            table.drop_column('datetime')
