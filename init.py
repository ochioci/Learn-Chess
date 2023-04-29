from stockfish import Stockfish
from mysql.connector import connect, Error


goodMoveThreshold = 0.5
#a move must be at least <goodMoveThreshold> times as good as the best move to be considered "correct"

#sends query q to mysql, returns response
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

#interface with stockfish python lib
stockfish = Stockfish(path="/usr/games/stockfish")
stockfish.update_engine_parameters({"Threads": 4, "Hash": 4096})
#there are 18 initial moves you can make, 2 for each pawn plus both knights!
openingMoves = stockfish.get_top_moves(18)
bestMoveScore = stockfish.get_top_moves(1)[0]['Centipawn']
print(bestMoveScore)

for variation in openingMoves:
        tempQuery = "INSERT INTO Puzzle (Position, seeded) VALUES ('" + variation['Move'] + "', 'n');"
        print(sendModifyQuery(tempQuery))
