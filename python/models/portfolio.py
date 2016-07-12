from orator import Model
from config import db
from orator.orm import has_one, belongs_to

Model.set_connection_resolver(db)

class Portfolio(Model):

    @has_one
    def portfolio(self):
        return Portfolio

    @belongs_to
    def user(self):
        return User
