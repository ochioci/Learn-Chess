from stockfish import Stockfish
from mysql.connector import connect, Error

def sendModifyQuery (q):
    output = []
    try:
        with connect (
            host = "localhost",
            user="tgbUser",
            password="1000onLich3ss!",
            database="tgbchess"
        ) as connection:
            with connection.cursor() as cursor:
                cursor.execute(q)
                connection.commit() #WE NEED THIS IF WE WANT TO EDIT ANYTHING (update, alter, delete, etc)
                for db in cursor:
                    output.append(db)
                return output
    except Error as e:
        return e


def sendGetQuery (q):
    output = []
    try:
        with connect (
            host = "localhost",
            user="tgbUser",
            password="1000onLich3ss!",
            database="tgbchess"
        ) as connection:
            with connection.cursor() as cursor:
                cursor.execute(q)
                for db in cursor:
                    output.append(db)
                return output
    except Error as e:
        return e


stockfish = Stockfish(path="/usr/games/stockfish") #this is the stockfish executable path on ubuntu for some reason!
stockfish.update_engine_parameters({"Threads": 4, "Hash": 4096}) #make engine stronger

seeds = sendGetQuery("SELECT * FROM Puzzle WHERE Position IS NOT NULL AND Solutions IS NOT NULL AND seeded = 'n'")
c = 0
for seed in seeds:
    statusUpdateQuery = "UPDATE Puzzle SET seeded = 'y' WHERE PuzzleID = " + str(seed[0])
    sendModifyQuery(statusUpdateQuery)
    c+=1
    print("doing seed " + str(c) + " out of " + str(len(seeds)))
    seedPos = seed[1]
    seedSols = seed[2].split(" ")
    for ss in seedSols:
        if (len(ss) > 1):
            tempQuery = "INSERT INTO Puzzle (Position, seeded) VALUES ('" + seedPos + " " + ss + "', 'n');"
            sendModifyQuery(tempQuery)
