<?php
class PointOfRental
{
    /**
     * Generate an SQL ORDER BY clause from a hash of column names and directions.
     *
     * @param array $hash An associative array where keys are column names or integers (for positional sorting) and values are 'ASC' or 'DESC'.
     * @param array $included_columns An associative array mapping valid column names to their database representations.
     * @return string The generated SQL ORDER BY clause.
     * @throws \Exception If an invalid sorting direction is provided.
     */
    protected static function generate(array $hash, array $included_columns): string
    {
        // $hash is an associative array of column names and directions ['id' => 'ASC', 'name' => 'DESC']
        // $included_columns is an associative array of column names and their database representations ['id' => 'table.id', 'name' => 'table.name']

        // method iterates through the hash and builds an SQL ORDER BY clause
        // it checks if the column exists in the included_columns array and if the direction is valid
        // if the column is an integer, it treats it as a positional sort
        // if the direction starts with a '-', it treats it as DESC, otherwise ASC
        // if the direction is not valid, it throws an exception

        $query_string = "";
        $hashes = [];
        if (!empty($hashTable)) // what is hashtable? // consideer checking if array also
        {
            foreach ($hash as $column => $direction) {
                
                if (in_array($direction, ['ASC', 'DESC'])) {
                    foreach ($included_columns as $columnName => $columnValue) {
                        if ($column == $columnName) {
                            $hashes[] = "$columnValue $direction ";
                        }
                    }
                    // so direction isn't ASC or DESC, must be int for the key or invalid
                } elseif (is_int($column)) { // checking if no $key was passed
                    // if no direction is passed, then $direction is the column name
                    $colDir = (substr($direction, 0, 1) == "-") ? " DESC" : " ASC";
                    // remove the - if it exists, but capture the field name
                    $columnName = (substr($direction, 0, 1) == "-") ? (substr($direction, 1)) : $direction;
                    // if columnName exists in included_columns, add the order by to hashes 
                    if (array_key_exists($columnName, $included_columns)) {
                        $hashes[] = "{$included_columns[$columnName]} $colDir ";
                    }

                } else {
                    throw new \Exception("Invalid criteria: $column $direction");
                }
            }
            if (!empty($hashes)) {
                $query_string = " ORDER BY " . join(",", $hashes); // changed "BY" to " " to fix syntax error
            }
        }
        return $query_string;
    }
}

// changes to make:
// fix variable name $hashTable to $hash
// handle exception
// add type hints
// add docstring
// add return type
// fix SQL syntax error in ORDER BY clause?

notes:
assumptions: 
a. the static method is part of a valid class.
b. the calling code invokes the static method, and inherits it (or is in the same class) since it is a protected method.
c. the 2 passed in parameters are both arrays, and it returns a string that is the ORDER BY clause for a SQL statement.


I. The script does have some errors in it.
    a. The variable $hashTable is not defined. It should be $hash.
    b. The SQL syntax in the ORDER BY clause is incorrect. It should be "ORDER BY" (this is also an assumption)

II. some changes to consider:
    a. Add type hints for the parameters and return type.
    b. Add a docstring to explain the method's purpose, parameters, and return value.
    c. Handle the exception properly instead of just throwing it.
    d. The variable names make my eyes roll back in my head and make me dizzy. Consider refactoring to more meaningful names depending on if statement blocks.
    e. The nested if staements could use ternary operators.

2. Line 19 - signals that the array could be a mixed array.

3. Output:
a.      "ORDER [BY] CreatedDate ASC, OrderType.Method DESC, JoinedTable.FieldValue DESC"

