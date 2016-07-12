from orator.migrations import Migration


class ChangeColumnCsoToMarketCap(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.table('stocks') as table:
            table.rename_column('cso', 'market_cap')

    def down(self):
        """
        Revert the migrations.
        """
        with self.schema.table('stocks') as table:
            table.rename_column('market_cap', 'cso')
