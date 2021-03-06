from orator.migrations import Migration


class CreatePortfoliosTable(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.create('portfolios') as table:
            table.increments('id')
            table.text('name')
            table.float('cash')
            table.integer('user_id').unsigned()
            table.foreign('user_id').references('id').on('users')
            table.integer('parent').unsigned().nullable()
            table.foreign('parent').references('id').on('portfolios')
            table.timestamps(use_current=True)

    def down(self):
        """
        Revert the migrations.
        """
        self.schema.drop('portfolios')
