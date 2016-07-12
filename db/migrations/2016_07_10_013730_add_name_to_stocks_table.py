from orator.migrations import Migration


class AddNameToStocksTable(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.table('stocks') as table:
            table.string('name')

    def down(self):
        """
        Revert the migrations.
        """
        with self.schema.table('stocks') as table:
            table.drop_column('name')
