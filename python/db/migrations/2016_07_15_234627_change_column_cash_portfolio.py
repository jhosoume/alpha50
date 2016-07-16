from orator.migrations import Migration


class ChangeColumnCashPortfolio(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.table('portfolios') as table:
            #table.raw('MODIFY COLUMN cash DOUBLE(15, 2);')
            pass

    def down(self):
        """
        Revert the migrations.
        """
        with self.schema.table('portfolios') as table:
            pass
