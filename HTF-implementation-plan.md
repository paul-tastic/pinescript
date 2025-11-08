# HTF Order Block Implementation Plan

## Goal
Detect order blocks on 1H timeframe and display them on 1m/5m charts WITHOUT repainting.

## Key Requirements
1. All order block detection logic must run on HTF (1H) data
2. Use `lookahead=barmerge.lookahead_off` to prevent repainting
3. Only process/update on HTF bar changes (not every LTF bar)
4. Display HTF order blocks on LTF chart

## Implementation Approach

### Option 1: Full HTF Variables (Current Direction)
**Pros:**
- Complete separation of HTF and LTF data
- Clear variable naming (htf_ prefix)
- All logic runs on HTF data

**Cons:**
- Requires extensive refactoring of entire indicator
- Multiple `request.security()` calls can be inefficient
- Arrays and var variables need careful handling with HTF data

### Option 2: Tuple/Array Return from request.security()
**Pros:**
- More efficient - single request.security() call
- Wraps all detection logic in a function
- Returns only necessary data (OB coordinates)

**Cons:**
- Cannot use var arrays inside request.security() context
- Limited to returning simple types (tuples of floats/ints)
- Would require complete rewrite of detection logic

### Option 3: HTF Indicator + LTF Display (Recommended)
**Pros:**
- Cleanest separation
- HTF logic stays intact
- LTF indicator just fetches and displays HTF OBs
- Can still use var arrays and boxes on LTF for display

**Cons:**
- Requires two separate files/indicators
- User would need to run HTF indicator first, then reference it from LTF

## Recommended Path Forward

I suggest **Option 1** with the following structure:

1. **Fetch HTF OHLC once** at the top
   ```pinescript
   [htf_open, htf_high, htf_low, htf_close, htf_time] = request.security(...)
   ```

2. **Detect HTF bar changes**
   ```pinescript
   htf_bar_changed = ta.change(htf_time) != 0
   ```

3. **Run ALL detection logic only when HTF bar changes**
   ```pinescript
   if htf_bar_changed
       // Update parsedHighs/Lows arrays
       // Check for new swings
       // Detect structure breaks
       // Store order blocks
   ```

4. **Display boxes every bar** (using stored OB data)
   ```pinescript
   // This runs every LTF bar to update box positions
   if htf_orderBlocks.size() > 0
       // Update box display
   ```

5. **Mitigation check can run every bar**
   ```pinescript
   // Check if current price (LTF or HTF) has mitigated any HTF OBs
   for [index, ob] in htf_orderBlocks
       if close > ob.barHigh or close < ob.barLow
           // Remove mitigated OB
   ```

## Question for User

Do you want me to:
A. Continue with full HTF refactor (Option 1) - will take significant work
B. Start fresh with a cleaner HTF-first design
C. Keep current indicator as-is for chart timeframe, and create a separate HTF version

The cleanest approach might be **B** - start with a new file that's designed from the ground up for HTF detection + LTF display.
