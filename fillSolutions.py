from stockfish import Stockfish
from mysql.connector import connect, Error

def sendModifyQuery (q):
    output = []
    try:
        with connect (
            host = "127.0.0.1",
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
            host = "127.0.0.1",
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
#stockfish.update_engine_parameters({"Threads": 4, "Hash": 4096}) #make engine stronger

rowsToUpdate = sendGetQuery("SELECT * FROM Puzzle WHERE Solutions IS NULL") #get each puzzle that doesn't have solutions yet
c = 0
for row in rowsToUpdate: #each row is a tuple, values corresponding to columns at their index
    c+=1
    print("solving #" + str(c) + " out of " + str(len(rowsToUpdate)))
    pos = row[1].split(" ")
    stockfish.set_position(pos)
    sol = stockfish.get_top_moves(18)
    #print(sol)
    #if its black to move, we want the lowest centipawn. white to move, the highest.
    print(pos)
    formattedSolutions = ''
    for s in sol:
        if (abs(sol[0]['Centipawn']-s['Centipawn']) <= abs(0.33 * sol[0]['Centipawn']) or abs(sol[0]['Centipawn']-s['Centipawn']) < 50): # its white to move
            formattedSolutions += s['Move'] + ' '
            print(s['Centipawn'])
        else:
            print("Cut " + str(s['Centipawn']))
    tempquery = "UPDATE Puzzle SET Solutions = '" + formattedSolutions + "' WHERE PuzzleID = " + str(row[0])
    sendModifyQuery(tempquery)
