import sys

def doubleIt(x):
	return 2*x

args = sys.argv[1].split(",")

params = []

for i in range(0, len(args)):
	if ("'" in args[i]):
		args[i] = args[i].replace("'", "")
		params.append(args[i])
	else:
		params.append(int(args[i]))


print(cube(*params))