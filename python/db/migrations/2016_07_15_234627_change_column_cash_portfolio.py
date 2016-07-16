from orator.migrations import Migration


class ChangeColumnCashPortfolio(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.table('portfolios') as table:
            table.drop_column('cash')
            table.double('total_cash', 15, 8)

    def down(self):
        """
        Revert the migrations.
        """
        with self.schema.table('portfolios') as table:
            table.drop_column('total_cash')
            table.float('cash')
