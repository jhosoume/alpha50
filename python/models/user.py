from orator import Model
from config import db
from orator.orm import has_many

Model.set_connection_resolver(db)

class User(Model):

    @has_many
    def portfolios(self):
        return Portfolio
