// difference between arrow function and regular function
// 1. Arrow functions do not have their own 'this' context, they inherit it from the surrounding scope.
// 2. Arrow functions cannot be used as constructors and will throw an error if used with 'new'.
// 3. Arrow functions do not have their own 'arguments' object, they inherit it from the surrounding scope.
// 4. Arrow functions cannot use 'yield', so they cannot be used as generator functions.

// arrow functions are considered shorthand for regular functions


function ListenerCollection(listeners)
{
    this.listeners = listeners;
}
Object.assign(ListenerCollection.prototype, {
    addListener: function(listener)
    {
        if(!angular.isFunction(listener)) return angular.noop;
        if(this.listeners.includes(listener))
        {
            this.listeners.push(listener);
        }
        var self = this;
        return function(){
         self.removeListener(listener);
        };
     },
 removeListener: function(listener)
    {
        var index = this.listeners.indexOf(listener);
        if(index > 0)
        {
            this.listeners.splice(index, 1);
        }
    },
 removeAllListeners: function()
    {
        this.listeners.length = 0;
    },
hasListeners: function()
    {
        return !!this.listeners.length;
    },
trigger: function()
    {
        var args = Array.prototype.slice.call(arguments);
        var promises = [];
        for(var i = 0; i < this.listeners.length; i++)
            {
                promises.push(this.listeners[i].apply(this.listeners[i], args));
            }
        return Promise.all(promises);
    }
});