twitter_sentiment_php
=====================

Implementing a Naive Bayesian algorithm and collecting proper datasets, this software gathers, preprocesses, classifies and stores Tweets. Data are shown using D3.js library.


Insert your credentials to connect to MySQL database in "connection.php" file.
Insert your Twitter dev credentials to connect to Twitter in "import/searchday.php" file.

The connection is made using a library developed by Abraham Williams for php (http://oauth.net).

Classification is made thanks to an implementation of the Opinion class developed by Ian Barber (http://www.phpir.com), adding to the polarity classification positive/negative a third, neutral class.

Datasets are provided. Positive and neutral ones have been taken from the The Stanford
collections (Available at http://cs.stanford.edu/people/alecmgo/trainingandtestdata.zip), obtained classifying the tweets based on the emoticons. For the neutral set we create our own dataset, collecting tweets from accounts of newspapers, ong, press-agencies, social media etc.

Following recent studies, to increase efficiency single-occurrence word have been removed from the dataset.
[Hassan Saif, Miriam Fernandez, Yulan He, Harith Alani, (2014). On stopwords, filtering and data sparsity for sentiment analysis of Twitter. In: LREC 2014, Ninth International Conference on Language Resources and Evaluation, 26-31 May 2014, Reykjavik,
Iceland, pp. 810–817.]
The script used to create a list of apax is in find_apax.py (the process must be done for each of the 3 classes of dataset).
To remove these words from the datasets you can use the "clean" finctione provided in the codes.
