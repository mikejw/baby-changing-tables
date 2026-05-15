import { motion } from 'framer-motion';

export default function LastFeedSummary({ loggedAt, cryLevel, formulaOunces }) {
    if (!loggedAt) {
      return (
        <motion.div className="rounded-lg border border-dashed border-[#19140035] dark:border-[#3E3E3A] p-6 text-sm text-[#706f6c] dark:text-[#A1A09A]">
          No feeds yet.
        </motion.div>
      )
    }
    return (
      <div className="rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] p-6 shadow-sm">
        <h2 className="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Latest feed</h2>
        <p className="mt-2 text-lg font-semibold">{loggedAt}</p>
        <dl className="mt-4 grid grid-cols-2 gap-3 text-sm">
          <motion.div>
            <dt className="text-[#706f6c] dark:text-[#A1A09A]">Cry</dt>
            <dd>{cryLevel} / 10</dd>
          </motion.div>
          <motion.div>
            <dt className="text-[#706f6c] dark:text-[#A1A09A]">Formula</dt>
            <dd>{formulaOunces ?? '—'}</dd>
          </motion.div>
        </dl>
      </div>
    )
  }