# Setup Grading System

The Nexus Strategy uses a letter-based grading system to evaluate the quality of each setup. Each letter represents a specific confluence factor that increases the probability of a successful trade.

## Grading Letters (SMDFEGR)

### S - Session Level Overlap
Zone overlaps with at least one session high/low level:
- Asian Session High/Low
- London Session High/Low
- Previous Day NY High/Low

### M - Multiple Sessions
Zone overlaps with 2 or more different session levels (requires S first).

### D - Deep Penetration
Price made a new extreme within the zone:
- For supply: New highest high for this zone entry
- For demand: New lowest low for this zone entry

### F - Fresh Zone
Zone has not been tested before (currently not tracked - manual evaluation).

### E - Engulfing Pattern
An engulfing candle pattern was detected during the reversal from the zone.

### G - Gap/FVG
A Fair Value Gap (BPR FVG or Inverted FVG) was detected as part of the setup.

### R - Round Number
Zone boundary is within 10 ticks of a round number (00, 25, 50, or 75).

## Grade Tiers

### Premium (5+ factors)
**Examples**: SMDEG, SMDEFR, SMDEGR
- Highest probability setups
- All major confluence factors present
- Ideal for taking full position size

### Quality (4 factors)
**Examples**: SMDE, SDEG, SMEG
- Strong setups with good confluence
- Missing 1-2 factors but still high quality
- Safe to trade with standard position size

### Minimum (3 factors)
**Examples**: SDE, SME, DEG
- Acceptable setups meeting minimum criteria
- Consider reducing position size
- Monitor closely for invalidation

### Below Minimum (<3 factors)
**Examples**: SD, DE, E, -
- **DO NOT TRADE**
- Insufficient confluence
- High risk of failure
- Wait for better setups

## Usage

The grade appears in:
1. **Debug Table** - Row #5 shows current setup grade with tier
2. **Trade Summary Table** - Grade column shows the grade for each completed trade

Use the grade to:
- Filter out low-quality setups (skip anything below 3 factors)
- Size positions appropriately (reduce size for Minimum tier)
- Review past trades to identify which confluence factors lead to wins
- Refine your trading rules based on grade performance
