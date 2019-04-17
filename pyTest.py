#!/usr/bin/python

import sys

def test(n):
	if n == 0:
		return 1
	else:
		return n * test(n-1)


print test(int(sys.argv[1]))
