file = open("sets/neg.neg", "r")
a = file.readlines()
from collections import Counter
counts = Counter()
ww = re.compile(r'\wt')
for sentence in a:
	counts.update(ww.findall(sentence.lower()))
a= open("sets/list1", "a")
for t in counts.keys():
	if counts[t] == 1:
		a.write(t + "\n")
a.close()