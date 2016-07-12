from orator import DatabaseManager

config = {
  'mysql': {
    'driver': 'mysql',
    'host': 'localhost',
    'database': 'alpha50',
    'user': 'development',
    'password': 'development'
  }
}

DATABASES = config

db = DatabaseManager(config)
