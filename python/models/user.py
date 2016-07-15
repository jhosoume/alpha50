import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator import Model
from config import db
from orator.orm import has_many
import re
import models.portfolio 

Model.set_connection_resolver(db)

class User(Model):

    __fillable__ = ['email']
    __guarded__ = ['id', 'password_hash']
    __timestamps__ = True

    @has_many
    def portfolios(self):
        return models.portfolio.Portfolio

    @staticmethod
    def is_valid_email(email):
        valid = email and re.search(r"\w+\@\w+\.\w+", email)
        return True if valid else False
    
    def is_valid(self):
        return User.is_valid_email(self.email)  

    def is_unique(self):
        return True if not User.where('email', self.email).count() else False

User.creating(lambda user: user.is_unique())
User.saving(lambda user: user.is_valid())
