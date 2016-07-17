from orator.migrations import Migration


class AddSectorInPortfolioValuationsTable(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.table('portfolio_valuations') as table:
            table.drop_column('value')
            table.double('portfolio_value', 15, 2)
            table.double('information_technology', 15, 2)
            table.double('energy', 15, 2)
            table.double('consumer_discretionary', 15, 2)
            table.double('health_care', 15, 2)
            table.double('industrials', 15, 2)
            table.double('telecommunications_services', 15, 2)
            table.double('financials', 15, 2)
            table.double('consumer_staples', 15, 2)

    def down(self):
        """
        Revert the migrations.
        """
        with self.schema.table('portfolio_valuations') as table:
            table.float('value')
            table.drop_column('portfolio_value')
            table.drop_column('information_technology')
            table.drop_column('energy')
            table.drop_column('consumer_discretionary')
            table.drop_column('health_care')
            table.drop_column('industrials')
            table.drop_column('telecommunications_services')
            table.drop_column('financials')
            table.drop_column('consumer_staples')
