# -*- coding: utf-8 -*-
import sys


try:
  from setuptools import setup
except ImportError:
  from distutils.core import setup
  
if sys.version_info <= (2, 4):
  error = 'Requires Python Version 2.5 or above... exiting.'
  print >> sys.stderr, error
  sys.exit(1)

setup(name='openrouteservice-py',
      version='0.1',
      description='Python client for requests to openrouteservice API services',
      classifiers=[
              'Development Status :: 4 - Beta',
              'License :: OSI Approved :: Apache Software License',
              'Operating System :: OS Independent',
              ],
      keywords='routing accessibility router OSM ORS openrouteservice openstreetmap'
               'isochrone',
      url='',
      author='Nils Nolde',
      author_email='nils@openrouteservice.org',
      license='Apache-2.0',
      packages='openrouteservice-py',
      install_requires = [
              'requests>=2.11.1,<3.0',],
      include_package_data=True,
      test_suite='nose.collector',
      tests_require=['nose'],
      zip_safe=False)