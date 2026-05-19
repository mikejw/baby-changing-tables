import StatCard from '../StatCard'
export default function AverageDailyFormula({ value, windowDays, daysWithFormula }) {
  const hint =
    value == null
      ? `No formula in last ${windowDays} days`
      : `Last ${windowDays} days · ${daysWithFormula} day${daysWithFormula === 1 ? '' : 's'} with formula`
  return (
    <StatCard
      label="Avg daily formula"
      value={value}
      suffix={value == null ? '' : ' oz'}
      hint={hint}
    />
  )
}