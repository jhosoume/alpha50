from orator.migrations import Migration


class CreateUsersTable(Migration):

    def up(self):
        """
        Run the migrations.
        """
        with self.schema.create('users') as table:
            table.increments('id')
            table.string('email')
            table.string('password_hash')
            table.timestamps(use_current=True)

    def down(self):
        """
        Revert the migrations.
        """
        self.schema.drop('users')
